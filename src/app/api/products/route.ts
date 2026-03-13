import { NextResponse } from 'next/server';
import prisma from '@/lib/prisma';

export async function GET(request: Request) {
  try {
    const { searchParams } = new URL(request.url);
    const category = searchParams.get('category');

    const products = await prisma.product.findMany({
      where: category ? {
        category: {
          equals: category
        }
      } : {},
      orderBy: {
        id: 'asc'
      }
    });

    // Auto-fix images for production databases silently
    for (const p of products) {
      if (p.name.includes('Banana Bread') && p.image !== '/images/bananabread.jpg') {
        await prisma.product.update({ where: { id: p.id }, data: { image: '/images/bananabread.jpg' } });
        p.image = '/images/bananabread.jpg';
      }
      if (p.name.includes('Matcha Latte') && p.image !== '/images/matchalatte.jpg') {
        await prisma.product.update({ where: { id: p.id }, data: { image: '/images/matchalatte.jpg' } });
        p.image = '/images/matchalatte.jpg';
      }
      if (p.name.includes('Chocolate Muffin') && p.image !== '/images/chocomuffin.jpg') {
        await prisma.product.update({ where: { id: p.id }, data: { image: '/images/chocomuffin.jpg' } });
        p.image = '/images/chocomuffin.jpg';
      }
    }

    // Balik laging array, kahit empty
    return NextResponse.json(products || []);
  } catch (error) {
    console.error('API_ERROR:', error);
    // Wag mag-crash, mag-return lang ng empty array
    return NextResponse.json([], { status: 500 });
  }
}

export async function POST(request: Request) {
  try {
    const body = await request.json();
    const product = await prisma.product.create({
      data: {
        name: body.name,
        slug: body.slug || body.name.toLowerCase().replace(/[^a-z0-9]+/g, '-'),
        description: body.description,
        price: body.price,
        category: body.category,
        image: body.image || '/images/default.png',
        status: body.status || 'available'
      }
    });
    return NextResponse.json(product, { status: 201 });
  } catch (error) {
    console.error('POST_API_ERROR:', error);
    return NextResponse.json({ error: 'Failed to create product' }, { status: 500 });
  }
}
