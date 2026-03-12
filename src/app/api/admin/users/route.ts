import { NextResponse } from 'next/server';
import { PrismaClient } from '@prisma/client';

const prisma = new PrismaClient();

export async function GET() {
  try {
    const users = await prisma.user.findMany({
      orderBy: { createdAt: 'desc' },
      select: {
          id: true,
          name: true,
          email: true,
          role: true,
          createdAt: true
      }
    });

    return NextResponse.json(users, { status: 200 });
  } catch (error) {
    console.error('Fetch Users Error:', error);
    return NextResponse.json({ error: 'Failed to fetch users' }, { status: 500 });
  }
}
