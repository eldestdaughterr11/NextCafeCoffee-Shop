import { NextRequest, NextResponse } from 'next/server';
import { PrismaClient } from '@prisma/client';

const prisma = new PrismaClient();

export async function DELETE(req: NextRequest, { params }: { params: { id: string } }) {
  try {
    const userId = parseInt(params.id);
    if (isNaN(userId)) return NextResponse.json({ error: 'Invalid ID' }, { status: 400 });

    // Assuming we don't have cascade delete set up yet, we must fail if user has orders OR we can simulate delete.
    // For simplicity, let's try to delete. Prisma throws if relation exists.
    await prisma.user.delete({
      where: { id: userId }
    });

    return NextResponse.json({ message: 'User deleted' }, { status: 200 });
  } catch (error) {
    console.error('Delete User Error:', error);
    return NextResponse.json({ error: 'Cannot delete user with connected orders.' }, { status: 400 });
  }
}
